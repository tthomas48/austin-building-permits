create table austin_building_permits(
    permit_number varchar(200) primary key,
    sub_type varchar(200),
    work_type varchar(200),
    permit_location varchar(200),
    date_issued varchar(200),
    work_description text,
    status varchar(200),
    folder_owner varchar(200),
    folder_owner_addrhouse varchar(200),
    folder_owner_addrstreet varchar(200),
    folder_owner_addrstreettype varchar(200),
    folder_owner_addrunittype varchar(200),
    folder_owner_addrunit varchar(200),
    folder_owner_addrcity varchar(200),
    folder_owner_addrprovince varchar(200),
    folder_owner_addrpostal varchar(200),
    folder_owner_phone varchar(200),
    property_owner varchar(200),
    property_owner_addrhouse varchar(200),
    property_owner_addrstreet varchar(200),
    property_owner_addrstreettype varchar(200),
    property_owner_addrunittype varchar(200),
    property_owner_addrunit varchar(200),
    property_owner_addrcity varchar(200),
    property_owner_addrprovince varchar(200),
    property_owner_addrpostal varchar(200),
    property_owner_phone varchar(200),
    total_existing_bldg_footage varchar(200),
    total_new_add_footage varchar(200),
    total_valuation_remodel varchar(200),
    total_job_valuation varchar(200),
    remodel_repair_footage varchar(200),
    number_of_units varchar(200),
    usage_category varchar(200),
    legal_description varchar(200)
) DEFAULT CHARSET=utf8;