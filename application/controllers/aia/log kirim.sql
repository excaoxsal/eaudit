
declare v_kirim TEXT;
BEGIN
	IF NEW."LOG_KIRIM" IS NULL THEN
		if TG_OP = 'DELETE' then  
    	v_kirim := 'Generate Jadwal';
		ELSE
		v_kirim := 'Bypass Via DB';
		end if;
	ELSE 
    v_kirim := NEW."LOG_KIRIM";
	END IF;
    IF TG_OP = 'INSERT' THEN
        INSERT INTO "LOG_ALL" ("TABLE_NAME", "OPERASI", "QUERY_TEXT", "DATA_SEBELUM", "DATA_SESUDAH", "ID_TARGET","LOG_KIRIM")
        VALUES (TG_TABLE_NAME, 'INSERT', 
                'INSERT INTO ' || TG_TABLE_NAME || ' VALUES(' || row_to_json(NEW) || ');',
                NULL, row_to_json(NEW), NEW."ID_RE",v_kirim);
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO "LOG_ALL" ("TABLE_NAME", "OPERASI", "QUERY_TEXT", "DATA_SEBELUM", "DATA_SESUDAH", "ID_TARGET","LOG_KIRIM")
        VALUES (TG_TABLE_NAME, 'UPDATE', 
                'UPDATE ' || TG_TABLE_NAME || ' SET ' || ' VALUES(' || row_to_json(NEW) || ') WHERE id = ' || NEW."ID_RE" || ';',
                row_to_json(OLD), row_to_json(NEW), NEW."ID_RE",v_kirim);
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO "LOG_ALL" ("TABLE_NAME", "OPERASI", "QUERY_TEXT", "DATA_SEBELUM", "DATA_SESUDAH", "ID_TARGET","LOG_KIRIM")
        VALUES (TG_TABLE_NAME, 'DELETE', 
                'DELETE FROM ' || TG_TABLE_NAME || ' WHERE id = ' || OLD."ID_RE" || ';',
                row_to_json(OLD), NULL, OLD."ID_RE",v_kirim);
        RETURN OLD;
    END IF;
    RETURN NULL; 
END;
