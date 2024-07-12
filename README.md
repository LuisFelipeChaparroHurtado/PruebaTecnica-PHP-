# Aplicación de Gestión de Empleados en Laravel

## Descripción


Este software de inventario ha sido desarrollado para la empresa **Comboplay SAS** con el objetivo de gestionar la asignación de activos, como portátiles, móviles, monitores y teclados, a sus colaboradores. La aplicación permite:

- **Gestión de Activos**: Crear, editar y eliminar registros de activos de la empresa.
- **Gestión de Colaboradores**: Crear, editar y eliminar registros de los colaboradores.
- **Listado de Registros**: Mostrar todos los activos y colaboradores en la base de datos.
- **Asignación de Activos**: Un módulo que permite asignar activos a un colaborador mediante el ID y serial del activo, junto con el ID del colaborador. 
- **Registro de Asignaciones**: Mantener un log de cada asignación realizada, que incluye información sobre el activo, datos del colaborador y el usuario que realizó la asignación.

Este sistema busca optimizar la gestión de recursos dentro de la empresa, asegurando un seguimiento claro y eficiente de los activos asignados a cada empleado.


## Requisitos

- PHP >= 8.1.6
- Composer
- Laravel >= 5.2.1
- MySQL

## Instalación

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/tuusuario/tu-repositorio.git

## Crea la base de datos y inserta algunos datos

 - BASE DE DATOS.txt : Aca podras visualizar la base de datos en SQL
 - Insertar datos (EJEMPLO)

 INSERT INTO employees (name, document_type, document_number, position, department) VALUES ('Alice Smith', 'Passport', 123456, 'Manager', 'Sales');
 INSERT INTO employees (name, document_type, document_number, position, department) VALUES ('Bob Johnson', 'ID Card', 789012, 'Engineer', 'Development');
 INSERT INTO employees (name, document_type, document_number, position, department) VALUES ('Carol Williams', 'ID Card', 345678, 'Analyst', 'Marketing');

 INSERT INTO company_assets (serial_code, trademark, reference, description, employees_id) VALUES ('ABC123', 'Dell', 'Latitude 5400', 'Laptop with 16GB RAM', 1);
 INSERT INTO company_assets (serial_code, trademark, reference, description, employees_id) VALUES ('XYZ789', 'HP', 'EliteBook 840', 'Laptop with 8GB RAM', 2);
 INSERT INTO company_assets (serial_code, trademark, reference, description, employees_id) VALUES ('LMN456', 'Apple', 'MacBook Pro', 'Laptop with 32GB RAM', 3);

 INSERT INTO logs (employees_id, company_assets_id, assigner, payload) VALUES (1, 1, 'Admin', '{"action": "assigned", "timestamp": "2024-07-10T10:00:00Z"}');
 INSERT INTO logs (employees_id, company_assets_id, assigner, payload) VALUES (2, 2, 'Admin', '{"action": "assigned", "timestamp": "2024-07-11T11:00:00Z"}');
 INSERT INTO logs (employees_id, company_assets_id, assigner, payload) VALUES (3, 3, 'Admin', '{"action": "assigned", "timestamp": "2024-07-12T12:00:00Z"}');



## Inicia el servidor

- php artisan serve