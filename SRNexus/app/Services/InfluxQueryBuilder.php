<?php

namespace App\Services;

use InvalidArgumentException;

class InfluxQueryBuilder
{
    protected array $sentences = [];
    protected array $durationUnits = ["inf", "y", "mo", "w", "d", "h", "m", "s", "ms", "us", "µs", "ns"];

    /**
     * Selecciona el bucket de InfluxDB a usar.
     *
     * @param string $db Nombre del bucket.
     * @return self
     */
    public function db(string $db): self
    {
        $this->sentences[] = "from(bucket: \"{$db}\")";
        return $this;
    }

    /**
     * Filtra por tabla o "point".
     *
     * @param string $table Nombre de la tabla o "measurement".
     * @return self
     */
    public function table(string $table): self
    {
        $this->sentences[] = " |> filter(fn: (r) => r[\"_measurement\"] == \"{$table}\")";
        return $this;
    }

    /**
     * Define un rango de tiempo para los datos.
     *
     * @param string $start Fecha/hora de inicio en formato Influx.
     * @param string|null $end Fecha/hora de fin en formato Influx (opcional).
     * @return self
     */
    public function range(string $start, ?string $end = null): self
    {
        if ($end) {
            $this->sentences[] = " |> range(start: {$start}, stop: {$end})";
        } else {
            $this->sentences[] = " |> range(start: {$start})";
        }
        return $this;
    }

    /**
     * Filtra los datos por un campo específico.
     *
     * @param string $field Nombre del campo.
     * @return self
     */
    public function filterField(string $field): self
    {
        $this->sentences[] = " |> filter(fn: (r) => r[\"_field\"] == \"{$field}\")";
        return $this;
    }

    /**
     * Filtra los datos por una clave y un valor.
     *
     * @param string $key Clave del filtro.
     * @param string $value Valor del filtro.
     * @return self
     */
    public function filter(string $key, string $value): self
    {
        $this->sentences[] = " |> filter(fn: (r) => r[\"{$key}\"] == \"{$value}\")";
        return $this;
    }

    /**
     * Aplica múltiples filtros a los datos.
     *
     * @param array $filters Array asociativo de clave-valor.
     * @return self
     */
    public function multiFilters(array $filters): self
    {
        foreach ($filters as $key => $value) {
            $this->filter($key, $value);
        }
        return $this;
    }

    /**
     * Ordena los datos por columnas específicas.
     *
     * @param string $columns Columnas para ordenar.
     * @return self
     */
    public function sort(string $columns): self
    {
        $this->sentences[] = " |> sort(columns: [{$columns}])";
        return $this;
    }

    /**
     * Limita el número de filas en la salida.
     *
     * @param int $limit Número máximo de filas.
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->sentences[] = " |> limit(n: {$limit})";
        return $this;
    }

    /**
     * Agrupa los datos por columnas específicas.
     *
     * @param string $columns Columnas para agrupar.
     * @return self
     */
    public function group(string $columns): self
    {
        $this->sentences[] = " |> group(columns: [{$columns}])";
        return $this;
    }

    /**
     * Calcula un promedio móvil de los datos.
     *
     * @param int $value Número de puntos para el promedio móvil.
     * @return self
     */
    public function movingAverage(int $value): self
    {
        $this->sentences[] = " |> movingAverage(n: {$value})";
        return $this;
    }

    /**
     * Obtiene el primer valor de los datos.
     *
     * @return self
     */
    public function first(): self
    {
        $this->sentences[] = " |> first()";
        return $this;
    }

    /**
     * Obtiene el último valor de los datos.
     *
     * @return self
     */
    public function last(): self
    {
        $this->sentences[] = " |> last()";
        return $this;
    }

    /**
     * Calcula el promedio de los datos.
     *
     * @return self
     */
    public function mean(): self
    {
        $this->sentences[] = " |> mean()";
        return $this;
    }

    /**
     * Obtiene el valor mínimo de los datos.
     *
     * @return self
     */
    public function min(): self
    {
        $this->sentences[] = " |> min()";
        return $this;
    }

    /**
     * Obtiene el valor máximo de los datos.
     *
     * @return self
     */
    public function max(): self
    {
        $this->sentences[] = " |> max()";
        return $this;
    }

    /**
     * Crea una ventana de tiempo para los datos.
     *
     * @param int $time Duración de la ventana.
     * @param string $scale Unidad de tiempo (y, mo, w, d, h, m, s, etc.).
     * @return self
     */
    public function window(int $time, string $scale): self
    {
        if ($time <= 0) {
            throw new InvalidArgumentException("El valor de 'time' debe ser mayor que cero.");
        }

        if (!in_array($scale, $this->durationUnits, true)) {
            throw new InvalidArgumentException("El valor de 'scale' debe ser uno de los siguientes: " . implode(", ", $this->durationUnits));
        }

        $this->sentences[] = " |> window(every: {$time}{$scale})";
        return $this;
    }

    public function aggregateWindow(int $every, string $scale, string $fn): self
    {
        if (!in_array($scale, $this->durationUnits, true)) {
            throw new InvalidArgumentException("El valor de 'scale' debe ser uno de los siguientes: " . implode(", ", $this->durationUnits));
        }

        $this->sentences[] = " |> aggregateWindow(every: {$every}{$scale}, fn: {$fn}, createEmpty: false)";
        return $this;
    }


    /**
     * Devuelve la consulta estructurada.
     *
     * @return string
     */
    public function get(): string
    {
        return implode('', $this->sentences);
    }
}
