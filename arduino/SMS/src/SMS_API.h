#ifndef SMS_API_h
#define SMS_API_h

#include "SPI.h"
#include "Ethernet.h"

class SMS_API
{
private:
    byte * mac_addr;
    IPAddress ip_addr;
    uint8_t port;
    EthernetServer server;
public:
    SMS_API(byte *, IPAddress, uint8_t);
    void initializeServer();
    void startServer();
    void serve();
    ~SMS_API();
};



#endif