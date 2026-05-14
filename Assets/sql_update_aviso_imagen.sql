-- Script para agregar la columna a_Imagen a la tabla aviso
-- Ejecutar este script UNA SOLA VEZ en la base de datos

ALTER TABLE `aviso` 
ADD COLUMN `a_Imagen` VARCHAR(255) NOT NULL DEFAULT '' 
AFTER `a_Escrollable`;

-- Verificar que se agregó correctamente
-- DESCRIBE aviso;
