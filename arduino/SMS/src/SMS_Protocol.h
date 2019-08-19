#ifndef SMS_Protocol_h
#define SMS_Protocol_h

/*
 *  SMS Communication Protocol
 *  --------------------------
---------------------
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
    char PrivateApiKey[8];
    bool Connected;
    StaticJsonDocument<JSON_OBJECT_SIZE(MAX_SENSORS)> data;
    bool request(char*) const;
  public:
    SMS_Protocol(char*);
    ~SMS_Protocol() = 0;
    void check();
    void serializeAndSend();
}

#endif
