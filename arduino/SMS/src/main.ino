#include "SMS_Protocol.h"

using namespace SMS;

SMS_Protocol sms = SMS_Protocol("1AFG34SZ");

void setup()
{
    setInitialPinMode();
}


void loop()
{
  Alert::Started();
  Alert::LedWorking();

  sms.check();

}
