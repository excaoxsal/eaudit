CREATE OR REPLACE FUNCTION log_changes()
RETURNS TRIGGER AS $$
declare v_kirim TEXT;
BEGIN
	IF NEW."LOG_KIRIM" IS NULL THEN
		if TG_OP = 'DELETE'
    	v_kirim := 'Bypass via DB';
	ELSE 
    v_kirim := NEW."LOG_KIRIM";
	END IF;
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_tabel (tabel_name, operasi, query_text, data_sebelum, data_sesudah, id_target,log_kirim)
        VALUES (TG_TABLE_NAME, 'INSERT', 
                'INSERT INTO ' || TG_TABLE_NAME || ' VALUES(' || row_to_json(NEW) || ');',
                NULL, row_to_json(NEW), NEW."ID_RE",v_kirim);
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_tabel (tabel_name, operasi, query_text, data_sebelum, data_sesudah, id_target,log_kirim)
        VALUES (TG_TABLE_NAME, 'UPDATE', 
                'UPDATE ' || TG_TABLE_NAME || ' SET ' || ' VALUES(' || row_to_json(NEW) || ') WHERE id = ' || NEW."ID_RE" || ';',
                row_to_json(OLD), row_to_json(NEW), NEW."ID_RE",v_kirim);
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_tabel (tabel_name, operasi, query_text, data_sebelum, data_sesudah, id_target,log_kirim)
        VALUES (TG_TABLE_NAME, 'DELETE', 
                'DELETE FROM ' || TG_TABLE_NAME || ' WHERE id = ' || OLD."ID_RE" || ';',
                row_to_json(OLD), NULL, OLD."ID_RE",v_kirim);
        RETURN OLD;
    END IF;
    RETURN NULL; 
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER log_all_delete
AFTER DELETE ON "RESPONSE_AUDITEE_D"
FOR EACH ROW
EXECUTE FUNCTION log_all();

CREATE TRIGGER log_all_update
AFTER UPDATE ON "RESPONSE_AUDITEE_D"
FOR EACH ROW
EXECUTE FUNCTION log_all();

CREATE TRIGGER log_all_insert
AFTER INSERT ON "RESPONSE_AUDITEE_D"
FOR EACH ROW
EXECUTE FUNCTION log_all();