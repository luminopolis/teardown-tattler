alter table wp_properties modify `311_name` char(64);
alter table wp_properties modify `311_case_summary` char(64);
alter table wp_properties modify `311_address` char(255);
update  wp_properties set `311_case_summary` = "Vacant Structure Open to Entry" WHERE `311_case_summary` = "Vacant Structure Open to";

