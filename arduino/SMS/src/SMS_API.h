#ifndef SMS_API_h
#define SMS_API_h

// #include "SPI.h"
#include "SMS.h"
#include "Ethernet.h"
#include "utility/w5100.h"

class SMS_API
{
private:
    SMS * sms;
    byte * mac_addr;
    IPAddress ip_addr;
    IPAddress gateway_addr;
    IPAddress dns_addr;
    IPAddress subnet_addr;
    uint16_t port;
    EthernetServer server = EthernetServer(80);
public:
    SMS_API(SMS * sms, IPAddress ip, IPAddress gateway, IPAddress dns, IPAddress subnet, uint16_t port);
    void startServer();
    void getHomepage(EthernetClient&);
    void getAllSensors(EthernetClient&);
    void serve();
    ~SMS_API();
};



#endif