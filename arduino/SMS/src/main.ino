
#include "SMS_Protocol.h"

// Notes:
//  - Destructors missing (not necessary if only one run)
//  - Deep copy (not necessary)

SMS * sms = new SMS();
SMS_Protocol * smsp = new SMS_Protocol("1AFG34SZ", sms);

void setup()
{
  sms->setInitialPinMode();
}


void loop()
{
  sms->Started();
  sms->LedWorking();

  smsp->check();
}
