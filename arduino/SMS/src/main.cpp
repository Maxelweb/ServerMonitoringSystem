
#include "SMS_API.h"


SMS * sms = new SMS();
SMS_API * api = new SMS_API(
                      sms,
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
  sms->initStartup();

  // Cycle
  sms->updateSensors();

  // Offline alerts
  sms->checkAlarms();
  //sms->LedConnected(false); // FIXME: pass if lan is connected
  sms->checkAlarms();

 
  // LAN connection
  api->serve();
  delay(250);
}
