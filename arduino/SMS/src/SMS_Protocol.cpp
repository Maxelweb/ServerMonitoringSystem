#include "SMS_Protocol.h"


SMS_Protocol::SMS_Protocol(String api, SMS * s)
{
  if(api.length() != 8)
    PrivateApiKey = api;
  else
    PrivateApiKey = "1234567";

    Connected = false;
    Parent = s;

}

bool SMS_Protocol::request(String compared) const
{
  if(Serial.available() > 0)
    return Serial.readString().equals(compared);

  return false;
}

void SMS_Protocol::check()
{
  if(request("plz"))
  {
    if(Connected)
      Serial.println('x');
    else
    {
      Serial.println('y');
      delay(50);

      if(!request(PrivateApiKey))
      {
        Serial.println('x');
        Serial.println("bye");
      }
      else
      {
        Serial.println('y');
        Connected = true;
        delay(50);
      }
    }
  }

  if(Connected && request("plz data"))
  {
    // Getting JSON DATA
    // Serial.println("JSON_DATA");
    serialize();
    serializeJson(Data, Serial);
    delay(100);
  }

  if(Connected && request("bye"))
  {
    Serial.println("bye");
    Connected = false;
  }

}

void SMS_Protocol::serialize()
{
  Parent->updateTH();
  Data["temperature"] = Parent->getTemperature();
  Data["humidity"] = Parent->getHumidity();
  Data["door"] = Parent->isDoorOpen() ? 1 : 0;
  Data["light"] = Parent->isLightUp() ? 1 : 0;
}
