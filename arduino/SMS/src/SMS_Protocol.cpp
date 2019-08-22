#include "SMS_Protocol.h"


SMS_Protocol::SMS_Protocol(String api, SMS * s)
{
    PrivateApiKey = api;

    Connected = false;
    Parent = s;
}

String SMS_Protocol::request() const
{
  if(Serial.available() > 0)
    return Serial.readString();

  return "";
}

void SMS_Protocol::check()
{
  String req = request();

  //Serial.println("Ready..");
  // delay(2000);

  if(req == "plz")
  {
    if(Connected)
      Serial.println('x');
    else
    {
      Serial.println('y');
      delay(100);

      if(request() != PrivateApiKey)
      {
        Serial.println('x');
        Serial.println("bye");
        delay(100);
      }
      else
      {
        Serial.println('y');
        Connected = true;
      }
    }
  }

  if(Connected && req == "plz data")
  {
    serialize();
    // serializeJson(Data, Serial);
    delay(100);
  }

  if(Connected && req == "bye")
  {
    Serial.println("bye");
    Connected = false;
  }

}

void SMS_Protocol::serialize()
{
  Parent->updateTH();
 /* Data["temperature"] = Parent->getTemperature();
  Data["humidity"] = Parent->getHumidity();
  Data["door"] = Parent->isDoorOpen() ? 1 : 0;
  Data["light"] = Parent->isLightUp() ? 1 : 0;
  */
  Serial.print(Parent->getTemperature());
  Serial.print(",");
  Serial.print(Parent->getHumidity());
  Serial.print(",");
  Serial.print(Parent->isDoorOpen());
  Serial.print(",");
  Serial.println(Parent->isLightUp());
}
