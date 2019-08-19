#include "SMS_Protocol.h"

SMS_Protocol::SMS_Protocol(String api)
{
  if(api.length() != 8)
    PrivateApiKey = api;
  else
    PrivateApiKey = "1234567";

    Connected = false;
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
    serializeJson(data, Serial);
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
  SMS::updateTH();
  data["temperature"] = SMS::getTemperature();
  data["humidity"] = SMS::getHumidity();
  data["door"] = SMS::isDoorOpen() ? 1 : 0;
  data["light"] = SMS::isLightUp() ? 1 : 0;
}
