#ifndef Sensor_h
#define Sensor_h


class Sensor
{
	private:
		const int pin;
		const char id;

	public:
		Sensor(int, char);
		virtual ~Sensor() = 0;

		int getPin() const;
		char getId() const;
		virtual serialize() const = 0;
};

#endif