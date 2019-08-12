#ifndef ServerMonitoringSystem_h
#define ServerMonitoringSystem_h



#define TempPIN = 0;
#define DoorPIN = 0;
#define PresencePIN = 0;



namespace ServerMonitoringSystem
{

	class SensorController
	{
		private:
			bool working;	

		public:
			SensorController();
			~SensorController();

			void setInitialPinMode();
			void getSensorsStatus(unsigned int);
			void serializeSensors(); // JSON implementations
			
	};


	void saveToSD(/* JSON item*/);
	void loadFromSD(/* JSON item*/);


}

#endif