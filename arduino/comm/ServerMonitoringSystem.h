#ifndef ServerMonitoringSystem_h
#define ServerMonitoringSystem_h

class ServerMonitoringSystem
{
	private:
		static const unsigned int pinSensorTemp = 0;
		static const unsigned int pinSonarDoor = 0;
		static const unsigned int pinSonarPresence = 0;
		

	public:
		ServerMonitoringSystem();
		~ServerMonitoringSystem();
	
};



#endif