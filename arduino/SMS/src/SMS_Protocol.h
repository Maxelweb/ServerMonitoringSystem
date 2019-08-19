#ifndef SMS_Protocol_h
#define SMS_Protocol_h

#include "SMS.h"

/*

SMS Communication Protocol
--------------------------
 < Request (Raspberry / PC - Max 8 chars)
 > Response (Arduino)
---------------------
HANDSHAKE
    < plz
     > x (refused)
     > y (accepted)
      < [API_KEY]
        > x (refused)
        > y (accpeted)
---------------------
DATA
  < plz data
    > [JSON_OBJECT_DOCUMENT]
---------------------
CLOSE
  < bye
  > bye
---------------------
 */


class SMS_Protocol
{
  private:
    String PrivateApiKey;
    bool Connected;
    StaticJsonDocument<JSON_OBJECT_SIZE(4)> Data;
    bool request(String) const;
    void serialize();
    SMS * Parent;
  public:
    SMS_Protocol(String, SMS*);
    void check();
};

#endif
