# Promtopolis

School Project for [2IMD](https://www.thomasmore.be/en/ba-xd)

## Table of Contents

- [About](#about)
- [Installation](#installation)
- [Contributing](#contributing)
- [Contact](#contact)

## About

Promtopolis is an app that allows users to create their own vegetable garden. Users can add sensors to their garden to measure soil moisture, temperature, light intensity, CO2 levels, and oxygen. The app provides feedback based on the sensor data and the selected plants, helping users grow their plants in the best possible way.

## Installation

To install Promtopolis on your own system, follow these steps:

1. Type `composer install` in your terminal to install the necessary dependencies from the `composer.json` file. The required dependency is `sengrid`.
2. Type `composer dump-autoload` in your terminal to update the autoload with the newly added namespaces.
3. Add a `config` folder into the `classes` directory and place a `config.ini` file inside it.
4. In the `config.ini` file, provide your database host, name, user, and password.
5. In the `config.ini` file, add your SendGrid API key.
6. Purchase a photoresistor sensor and a DHT-11 temperature sensor for Arduino.
7. Purchase an Arduino Leonardo.
8. Purchase a LoRa network gateway.
9. Connect the sensors to the Arduino Leonardo using a featherboard, ensuring that you use PIN 5 for the DHT-11 sensor.
10. Create an IoT account on [The Things Stack](https://eu1.cloud.thethings.network/).
11. Connect your gateway to your IoT account.
12. Create an application using your Arduino Leonardo.
13. Open the `ttn_temperature_LoRa.cpp` file and fill in your app_eui, app_key, and frequency plan.
14. Run the website.

You can access the actual website at [https://tibomertens.be/sensorsprout/](https://tibomertens.be/sensorsprout/). Please note that this is a demo and requires specific hardware to work.

## Contributing

Contributions to this repository are not allowed at the moment.

## Contact

For any inquiries or questions, you can reach out to me us via email.
Lead developer: <tibomertens25@gmail.com>.
Lead designer/branding: <quintt.adam@hotmail.com>
