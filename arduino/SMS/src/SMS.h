#ifndef ServerMonitoringSystem_h
#define ServerMonitoringSystem_h

#include "Arduino.h"
#include "HCSR04.h"
#include "NewTone.h"
#include "DHT.h"

#define LEDPIN 2
#define BUZZPIN 3
#define LEDCONN 5

#define DHTTYPE DHT11 
#define THPIN 4
#define LIGHTPIN A0

#define SONARPIN_ECHO 7
#define SONARPIN_TRIG 8
#define SMAX_DISTANCE 4000
#define SMIN_DISTANCE 20

#define UPDATE_INTERVAL 2000

class SMS
{
private:
    UltraSonicDistanceSensor * DoorSonar;
    DHT * THSensor;
    bool Startup;
    float Temperature;
    float Humidity;
    double DoorDistance;
    int LightPower;
    unsigned long currentInterval;

public:
    bool EnableAlarm;
    SMS();
    void setInitialPinMode();
    bool isDoorOpen();
    bool isLightUp();
    int getTemperature() const;
    int getHumidity() const;
    void updateSensors();

    void Started();
    void Alarms();
    void LedAlerts();
    void LedConnected(bool);
};

#endif
