# FabricaDeCarros Project

## Overview
FabricaDeCarros is a PHP project that simulates a car manufacturing and sales system. It allows users to create, sell, and list cars through a simple command-line interface.

## Project Structure
```
FabricaDeCarros
├── src
│   ├── Carro.php
│   ├── Fabrica.php
│   └── processa.php
├── menu.php
└── README.md
```

## Files Description

- **src/Carro.php**: Defines the `Carro` class, representing a car with properties for model and color. It includes methods to get the model and color of the car.

- **src/Fabrica.php**: Defines the `Fabrica` class, representing a car factory. It includes methods to manufacture cars, sell cars, and list all manufactured cars.

- **src/processa.php**: The main script for user interaction. It implements a menu that allows users to manufacture cars, sell cars, and view car information.

- **menu.php**: Contains the menu structure and options for user interaction, guiding the user through the available actions.

## Setup Instructions
1. Clone the repository or download the project files.
2. Navigate to the project directory.
3. Ensure you have PHP installed on your machine.
4. Run the `processa.php` script from the command line to start the application.

## Usage Guidelines
- Follow the on-screen menu prompts to manufacture or sell cars.
- Enter the required details when prompted, such as the model and color of the car.
- Use the listing option to view all manufactured cars.

## License
This project is open-source and available for modification and distribution under the MIT License.