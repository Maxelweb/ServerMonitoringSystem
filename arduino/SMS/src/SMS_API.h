#ifndef SMS_API_h
#define SMS_API_h

#include "SMS.h"
#include "Ethernet.h"
#include "uptime.h"

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
    EthernetServer server;
public:
    SMS_API(SMS * sms, IPAddress ip, IPAddress gateway, IPAddress dns, IPAddress subnet, uint16_t port);
    void startServer();
    void get(EthernetClient&, String, int);
    void get(EthernetClient&, String, String);
    void getHomepage(EthernetClient&);
    void getAllSensors(EthernetClient&);
    void getAllAlerts(EthernetClient&);
    int toggleIntrusionDetection();
    int toggleEnableAlarm();
    void serve();
};


#endif