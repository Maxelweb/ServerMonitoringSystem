#ifndef ServerMonitoringSystem_h
#define ServerMonitoringSystem_h

#include "Arduino.h"
#include "ArduinoJson.h"
#include "NewPing.h"
#include "NewTone.h"
#include "dht11.h"

#define LEDPIN 2
#define BUZZPIN 3

#define THPIN 4
#define LIGHTPIN A0

#define SONARPIN_ECHO 7
#define SONARPIN_TRIG 8
#define SMAX_DISTANCE 200

class SMS
{
  protected:
    NewPing * DoorSonar;
    dht11 * THSensor;
    bool Working;
    bool Startup;

  public:
    SMS();
    void setInitialPinMode();
    bool isDoorOpen();
    bool isLightUp();
    int getTemperature() const;
    int getHumidity() const;
    void updateTH();

    void LedWorking();
    void Started();
};

#endif
