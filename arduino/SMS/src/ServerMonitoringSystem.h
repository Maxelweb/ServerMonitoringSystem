#ifndef ServerMonitoringSystem_h
#define ServerMonitoringSystem_h


// Using #define instaed of variables to avoid memory allocation
// --> pre-processor (before compile-time)

// Temperature and Humidity (DHT-11) + Photoresistor

#define MAX_SENSORS 4
#define LEDPIN 2
#define BUZZPIN 3

#define THPIN 4
#define LIGHTPIN A0

#define SONARPIN_ECHO 7
#define SONARPIN_TRIG 8
#define SONAR_MAX_DISTANCE 200


namespace SMS
{


	NewPing DoorSonar(SONARPIN_TRIG, SONARPIN_ECHO, SONAR_MAX_DISTANCE);
	dht11 THSensor;

	bool Working = true;
	bool Startup = false;

	void setInitialPinMode()
	{
		Serial.begin(9600);

		pinMode(LEDPIN, OUTPUT);
		pinMode(BUZZPIN, OUTPUT);

		pinMode(THPIN, INPUT);
		pinMode(LIGHTPIN, INPUT);
	}


	bool isDoorOpen()
	{
		return DoorSonar.ping_cm() == 0;
	}

	void updateTH()
	{
		if(THSensor.read(THPIN) != 0)
			Working = false;
	}

	int getTemperature()
	{
		return THSensor.temperature;
	}

	int getHumidity()
	{
		return THSensor.humidity;
	}

	bool isLightUp()
	{
		return analogRead(LIGHTPIN) > 60;
	}


	namespace Alert
	{
		void LedWorking()
		{
			if(Working)
			{
				digitalWrite(LEDPIN, HIGH);
			}
			else
			{
				digitalWrite(LEDPIN, HIGH);
				delay(200);
				digitalWrite(LEDPIN, LOW);
				delay(200);
			}
		}

		void Started()
		{
			if(!Startup)
			{
				tone(BUZZPIN, 1000, 500);
				delay(1500);
				noTone(BUZZPIN);
				Startup = true;
			}
		}
	}

}


#endif
