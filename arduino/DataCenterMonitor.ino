
#include <Filters.h>
#include <DallasTemperature.h>
#include <Wire.h>

#define ONE_WIRE_BUS A0 // Pin ADC Sensor de temperatura
#define STABLE_TIMES 5  // Tiempos para estabilización del sensor

/* Sensor de temperatura */
OneWire oneWire(ONE_WIRE_BUS); 
DallasTemperature sensor(&oneWire);

float temperature = 0;
/********************************************************************/ 

/* Sensores de voltaje por cada una de las fases: R, S y T */
float testFrequency = 60;                     
float windowLength = 40.0/testFrequency; 
float intercept = -0.04;      
float slope = 0.0505; 

int sensor_r = 0;
int sensor_s = 0;
int sensor_t = 0;

float voltage_r = 0;
float voltage_s = 0;
float voltage_t = 0;

int count = 5;  // Intentos hasta que cada sensor de voltaje estabilice


unsigned long printPeriod = 500; // Tasa de refresco (ms)
unsigned long previousMillis = 0;

// Leer Temperatura 
float getTemperature(){
  sensor.requestTemperatures();
  return sensor.getTempCByIndex(0);
}

void setup() { 
  Serial.begin(9600); 
  //Serial.println("Calibrando ..."); Solo para depuración
  delay(1000); 
  sensor.begin(); 
}


void loop() {
  count = STABLE_TIMES;
  temperature = getTemperature();
  RunningStatistics inputStats_r, inputStats_s, inputStats_t;                
  inputStats_r.setWindowSecs( windowLength );
  inputStats_s.setWindowSecs( windowLength );
  inputStats_t.setWindowSecs( windowLength );
   
  while( true ) {   
    sensor_r = analogRead(A1);  
    sensor_s = analogRead(A2);
    sensor_t = analogRead(A3);
    inputStats_r.input(sensor_r); 
    inputStats_s.input(sensor_s); 
    inputStats_t.input(sensor_t); 
        
    if((unsigned long)(millis() - previousMillis) >= printPeriod){
      previousMillis = millis();   
      voltage_r = intercept + slope * inputStats_r.sigma(); 
      voltage_r = voltage_r * (40.3231) - 3;    
      voltage_s = intercept + slope * inputStats_s.sigma(); 
      voltage_s = voltage_s * (40.3231) - 3; 
      voltage_t = intercept + slope * inputStats_t.sigma(); 
      voltage_t = voltage_t * (40.3231);   
      if(count == 0){
        Serial.print(temperature); Serial.print(";");
        Serial.print(voltage_r); Serial.print(";");
        Serial.print(voltage_s); Serial.print(";");
        Serial.print(voltage_t); Serial.println("\n");
        count = STABLE_TIMES;
      }
      else count --;
    }
  }
}
