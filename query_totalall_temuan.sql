

SELECT
    "SUB_DIVISI",
    COUNT("ID_TEMUAN") AS total_temuan
FROM
    "TEMUAN_DETAIL"
GROUP BY
    "SUB_DIVISI";

SELECT
    "t"."SUB_DIVISI" as "subdivisi",
    "d"."NAMA_DIVISI" as "divisi",
    "d"."KODE_PARENT",
    SUM(CASE WHEN t."STATUS" = 'CLOSE' THEN 1 ELSE 0 END) AS closed,
    SUM(CASE WHEN t."STATUS" != 'CLOSE' THEN 1 ELSE 0 END) AS open,
    "i"."NOMOR_ISO" as "ISO",
    (SELECT COUNT("ID_RESPONSE") FROM "TEMUAN_DETAIL" LEFT JOIN "RESPONSE_AUDITEE_H" ON "ID_RESPONSE" = "ID_HEADER" WHERE "DIVISI" = d."KODE_PARENT") AS "TOTALALL"
FROM
    "TEMUAN_DETAIL" "t"
LEFT JOIN "RESPONSE_AUDITEE_H" "h" ON "t"."ID_RESPONSE" = "h"."ID_HEADER"
JOIN "TM_DIVISI" "d" ON "d"."KODE" = "t"."SUB_DIVISI"
JOIN "TM_ISO" "i" ON "i"."ID_ISO" = "h"."ID_ISO"
WHERE
    "d"."IS_CABANG" = 'N'
GROUP BY
	"d"."COUNT",
    "t"."SUB_DIVISI",
    "d"."NAMA_DIVISI",
    "d"."KODE_PARENT",
    "i"."NOMOR_ISO",
	"t"."ID_RESPONSE"
HAVING
    "t"."SUB_DIVISI" IS NOT NULL
ORDER BY
    "d"."COUNT" ASC;  -- Assuming "d"."KODE" is the correct column for ordering