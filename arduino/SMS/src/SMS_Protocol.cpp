#include "SMS_Protocol.h"

SMS_Protocol::SMS_Protocol(String api, SMS * s)
  : PrivateApiKey(api), Connected(FLAG_DEBUG), Parent(s), LastRequest()
{ }

void SMS_Protocol::updateRequest()
{
    if(Serial.available() > 0)
        LastRequest = Serial.readString();
    else 
        LastRequest = "";
}

void SMS_Protocol::check()
{
    updateRequest();

    if(LastRequest == "plz")
    {
        // Reconnection allowed 
        if(Connected)
            Connected = false;

        Serial.println('y');
        delay(100);
        updateRequest();

        if(LastRequest != PrivateApiKey)
        {
            Serial.println('x');
            delay(100);
        }
        else
        {
            Serial.println('y');
            Connected = true;
        }
    }
    else if(Connected)
    {
        if(LastRequest == "plz data")
            serialize();
        else if(LastRequest == "plz alarm off")
            Parent->EnableAlarm = false;
        else if(LastRequest == "plz alarm on")
            Parent->EnableAlarm = true;
        else if(LastRequest == "plz alarm")
            Serial.println(Parent->EnableAlarm == true ? 1 : 0);
        else if(LastRequest == "bye")
        {
            Serial.println("bye");
            Connected = false;
        }
    }
    
    serialize();

}

void SMS_Protocol::serialize()
{
    Serial.print(Parent->getTemperature());
    Serial.print(",");
    Serial.print(Parent->getHumidity());
    Serial.print(",");
    Serial.print(Parent->isDoorOpen());
    Serial.print(",");
    Serial.println(Parent->isLightUp());
}

bool SMS_Protocol::isConnected() const
{
    return Connected;
}