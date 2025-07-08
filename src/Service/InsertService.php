<?php

namespace Service;

class InsertService
{
    public function build(string $table, array $rows): array
    {
        $sqls = [];

        foreach ($rows as $row) {
            $columns = array_keys($row);
            $values = array_map([$this, 'quote'], array_values($row));

            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s);",
                $table,
                implode(', ', $columns),
                implode(', ', $values)
            );

            $sqls[] = $sql;
        }

        return $sqls;
    }

    private function quote($value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }

        return "'" . str_replace("'", "''", $value) . "'";
    }
}
