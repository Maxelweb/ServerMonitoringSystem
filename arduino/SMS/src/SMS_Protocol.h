#ifndef SMS_Protocol_h
#define SMS_Protocol_h

#include "SMS.h"

#define FLAG_DEBUG true

class SMS_Protocol
{
    private:
        String PrivateApiKey;
        bool Connected;
        SMS * Parent;
        String LastRequest;
        void updateRequest();
        void serialize();
    public:
        SMS_Protocol(String, SMS*);
        void check();
        bool isConnected() const;
};


#endif
