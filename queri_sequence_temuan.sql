CREATE OR REPLACE FUNCTION "MANAGE_SEQUENCE_TEMUAN"()
RETURNS TRIGGER AS $$
DECLARE
    existing_record RECORD;
	new_nomor_urut INTEGER;
	id_temuan INTEGER;
BEGIN
    -- Saat melakukan INSERT
	
    IF (TG_OP = 'INSERT') THEN
        -- Cek apakah sudah ada record dengan iso, divisi, dan tahun yang sama
        SELECT * INTO existing_record 
        FROM "SEQUENCE_TEMUAN" 
        WHERE "ID_ISO" = (select h."ID_ISO" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE") 
        AND "DIVISI" = (select h."DIVISI" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE")
        AND "TAHUN" = EXTRACT(YEAR FROM NEW."CREATED_AT");
		id_temuan = NEW."ID_TEMUAN";
        IF FOUND THEN
            -- Jika ada, update nomor urut dengan menambahkannya 1
            UPDATE "SEQUENCE_TEMUAN" 
            SET "NOMOR_URUT" = "NOMOR_URUT" + 1 
            WHERE "ID_ISO" = (select h."ID_ISO" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE") 
        	AND "DIVISI" = (select h."DIVISI" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE")
        	AND "TAHUN" = EXTRACT(YEAR FROM NEW."CREATED_AT")
			RETURNING "NOMOR_URUT" INTO new_nomor_urut;

        ELSE
            -- Jika tidak ada, tambahkan data baru dengan nomor urut 1
            INSERT INTO "SEQUENCE_TEMUAN" ("ID_ISO", "DIVISI", "TAHUN", "NOMOR_URUT") 
            VALUES ((select h."ID_ISO" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE"), (select h."DIVISI" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = NEW."ID_RESPONSE") , EXTRACT(YEAR FROM NEW."CREATED_AT"), 1)
			RETURNING "NOMOR_URUT" INTO new_nomor_urut;
        END IF;
		UPDATE "TEMUAN_DETAIL" 
        SET "POINT" = new_nomor_urut 
        WHERE "ID_TEMUAN" = id_temuan;
    END IF;

    -- Saat melakukan DELETE
    IF (TG_OP = 'DELETE') THEN
        -- Cek apakah ada record dengan iso, divisi, dan tahun yang sama
        SELECT * INTO existing_record 
        FROM "SEQUENCE_TEMUAN" 
        WHERE "ID_ISO" = (select h."ID_ISO" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = OLD."ID_RESPONSE") 
        AND "DIVISI" = (select h."DIVISI" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = OLD."ID_RESPONSE") 
        AND "TAHUN" = EXTRACT(YEAR FROM OLD."CREATED_AT");

        IF FOUND THEN
            -- Jika ada dan nomor_urut lebih dari 0, kurangi nomor_urut dengan 1
            IF existing_record.nomor_urut > 0 THEN
                UPDATE "SEQUENCE_TEMUAN" 
                SET "NOMOR_URUT" = "NOMOR_URUT" - 1 
                WHERE "ID_ISO" = (select h."ID_ISO" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = OLD."ID_RESPONSE") 
        		AND "DIVISI" = (select h."DIVISI" from "RESPONSE_AUDITEE_H" h where h."ID_HEADER" = OLD."ID_RESPONSE") 
        		AND "TAHUN" = EXTRACT(YEAR FROM OLD."CREATED_AT");
            END IF;
        END IF;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;



CREATE TRIGGER "TRIGGER_MANAGE_SEQUENCE_TEMUAN"
AFTER INSERT OR DELETE ON "TEMUAN_DETAIL"
FOR EACH ROW
EXECUTE FUNCTION "MANAGE_SEQUENCE_TEMUAN"();
