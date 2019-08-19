#ifndef ServerMonitoring_h
#define ServerMonitoring_h


// Using #define instaed of variables to avoid memory allocation
// --> pre-processor (before compile-time)

#define LEDPIN 2
#define BUZZPIN 3
#define THPIN 4 // Temperature and Humidity (DHT-11)
#define SONARPIN_ECHO 7
#define SONARPIN_TRIG 8
#define LIGHTPIN A0 // Photoresistor (Analog)



namespace SMS
{

	void setInitialPinMode()
	{
		pinMode(LEDPIN, OUTPUT);
	}

	namespace Alert
	{
		void Started()
		{
			return;
		}
	}

	//int getSensorValue(char);
	// void serializeSensors(); // JSON implementations

}


#endif
