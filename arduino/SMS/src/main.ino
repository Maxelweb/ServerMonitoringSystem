#include "Arduino.h"
#include "ArduinoJson.h"
#include "NewPing.h"
#include "dht11.h"
#include "ServerMonitoringSystem.h"

using namespace SMS;

void setup()
{
    setInitialPinMode();
}


void loop()
{
  Alert::Started();
  Alert::LedWorking();

}
