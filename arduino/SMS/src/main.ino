
#include "SMS_Protocol.h"

// Notes:
//  - Destructors missing (not necessary if only one run)
//  - Deep copy (not necessary)

SMS * sms = new SMS();
SMS_Protocol * smsp = new SMS_Protocol("SECRET", sms);


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
  sms->LedConnected(smsp->isConnected());
  sms->Alarms();

  // Serial connection
  smsp->check();
  delay(250);
}
