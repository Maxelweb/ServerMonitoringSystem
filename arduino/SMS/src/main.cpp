
#include "SMS.h"
#include "SMS_API.h"


SMS * sms = new SMS();
SMS_API * api = new SMS_API(
                      IPAddress(192, 168, 1, 1),  
                      IPAddress(192, 168, 1, 254), 
                      IPAddress(192, 168, 1, 254), 
                      IPAddress(255,255,255,0), 
                      80);

void setup()
{
  sms->setInitialPinMode();
  api->startServer();
}


void loop()
{
  // Startup sound
  sms->Started();

  // Cycle
  sms->updateSensors();

  // Offline alerts
  sms->LedAlerts();
  sms->LedConnected(false); // FIXME: pass if lan is connected
  sms->Alarms();

 
  // LAN connection
  api->serve();
  delay(100);
}
