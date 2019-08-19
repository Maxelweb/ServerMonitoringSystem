#include "SMS_Protocol.h"

SMS_Protocol::SMS_Protocol(char* api)
{
  if(sizeof(api) == 8)
    PrivateApiKey = api;
  else
    PrivateApiKey = "12345678";

    Connected = false;
}

bool SMS_Protocol::request(char * compared) const
{
  char request[8];
  char curr = -1;
  byte i = 0;

  while(Serial.available() > 0)
  {
    if(i < 7)
    {
      inChar = Serial.read();
      request[i] = curr;
      i++;
      request[i] = '\0';
    }
  }

  return strcmp(request, compared) == 0;
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
      request(PrivateApiKey);
    }
  }
}
