
#include "SMS_Protocol.h"


SMS * sms = new SMS();


void setup()
{
  sms->setInitialPinMode();
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
  
  delay(250);
}
