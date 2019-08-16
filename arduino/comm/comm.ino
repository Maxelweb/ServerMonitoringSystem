
// Test iniziali

#include "Arduino.h"
#include "ArduinoJson.h"
// #include "ServerMonitoringSystem.h"


int ledPin = 13;
StaticJsonDocument<JSON_OBJECT_SIZE(5)> dataj;


void setup() 
{
    pinMode(ledPin, OUTPUT);
    Serial.begin(9600);

    randomSeed(analogRead(0));
}


void loop() 
{
 
    dataj["id"] = "current";
    dataj["temperature"] = random(45);
    dataj["humidity"] = random(100);
    dataj["door"] = 1;
    dataj["light"] = 0;

    digitalWrite(ledPin, HIGH);
    delay(1000);
  
    /*for(byte n = 0; n < 150; n++)
    {
        Serial.write(n);
        delay(50);
    }*/

    serializeJson(dataj, Serial);

    digitalWrite(ledPin, LOW);
    delay(1000);

}
