#!/usr/bin/perl

###################################################
### Script para leer los datos desde el puerto serie
##################################################

use POSIX qw(strftime);
use LWP::UserAgent;

$logfile = "/var/www/akademica/rack/ambiente.log";
open(LOGFILE,">>$logfile") or die "No pude crear $logfile";
$usb_port = "/dev/ttyUSB0";
sysopen(PI,$usb_port, O_RDWR|O_NDELAY) or die "No puede abrirse $usb_port: $!";
open(PO,"+>&PI") or die "No puede duplicarse PI: $!";
select((select(PO), $| = 1)[0]);
print PO "\n";
do{
        $input = <PI>;
} while($input == NULL);
$timestamp= strftime "%d/%m/%Y;%H:%M:%S", localtime;
@data = split(';',$input);

if (($data[0] =~ /^[+-.0-9]+$/) && ($data[1] =~ /^[+-.0-9]+$/)){ # Debug input data
        if($data[0] < 50) {
                ##  R,S,T voltages
                $R = $data[1] + 3;
                $S = $data[2] + 3;
                $T = $data[3];
                chop $data[3];

                ## RTT average (check internet link status)
                $rtt = `/bin/ping -c 5 8.8.8.8|tail -1|cut -f5 -d'/'`;
        

                print  LOGFILE "$timestamp;$data[0];$R;$S;$T;$rtt";
                print "$data[0];$R;$S;$T;$rtt\n";

                ## Send data to Argus Ingenieria software
                $device=17020701;
                my $ua = LWP::UserAgent->new;
                my $server_endpoint = "http://argusingenieria.com/frozen2/ws/logger.php?data=$device;1.232965;-77292800;2500;1:$data[0];12:$R;13:$S;14:$T;7:$rtt";

                # set custom HTTP request header fields
                my $req = HTTP::Request->new(GET => $server_endpoint);
                $req->header('content-type' => 'text/plain');
                #$req->header('x-auth-token' => 'kfksj48sdfj4jd9d');

                my $resp = $ua->request($req);
                if ($resp->is_success) {
                        my $message = $resp->decoded_content;
                        print "Received reply: $message - \n";
                }
                else {
                        print "HTTP GET error code: ", $resp->code, "\n";
                        print "HTTP GET error message: ", $resp->message, "\n";
                }
        }
}
close(LOGFILE);
