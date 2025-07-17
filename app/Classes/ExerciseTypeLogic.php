<?php

namespace App\Classes;

class ExerciseTypeLogic
{
    public static function validateAndProcess(string $typeName, array $data): array
    {
        $errors = [];
        switch ($typeName) {
            case 'Multiple Choice':
                if (!isset($data['options']) || count($data['options']) < 2) {
                    $errors['options'] = 'Debes agregar al menos dos opciones.';
                }
                if (!in_array($data['solution'] ?? '', $data['options'] ?? [])) {
                    $errors['solution'] = 'La solución debe estar entre las opciones.';
                }
                break;
            case 'Fill in the Blanks':
                if (empty($data['solution'])) {
                    $errors['solution'] = 'Debes ingresar la solución.';
                }
                break;
            case 'True or False':
                $data['options'] = ['True', 'False'];
                if (!in_array($data['solution'] ?? '', $data['options'])) {
                    $errors['solution'] = 'La solución debe ser True o False.';
                }
                break;
            case 'Matching':
                if (!is_array($data['options']) || count($data['options']) < 2) {
                    $errors['options'] = 'Debes agregar al menos dos pares para relacionar.';
                }
                break;
            case 'Ordering':
                if (!is_array($data['options']) || count($data['options']) < 2) {
                    $errors['options'] = 'Debes agregar al menos dos elementos para ordenar.';
                }
                if (!is_array($data['solution'])) {
                    $errors['solution'] = 'La solución debe ser un array con el orden correcto.';
                }
                break;
            case 'Short Answer':
            case 'Essay':
                if (empty($data['solution'])) {
                    $errors['solution'] = 'Debes ingresar la respuesta.';
                }
                break;
            default:
                break;
        }
        return [
            'errors' => $errors,
            'data' => $data
        ];
    }
}
