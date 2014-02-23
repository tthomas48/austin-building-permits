create table geocode (
  permit_number varchar(200) primary key,
  date_issued varchar(200),
  permit_location varchar(200),
  latitude DECIMAL(9,6),
  longitude DECIMAL(9,6),
  census_block DECIMAL(9),
  census_block_group  DECIMAL(9),
  census_tract DECIMAL(9,2),
  census_county_fips DECIMAL(9),
  census_state_fips DECIMAL(9),
  census_cbsa_fips DECIMAL(9),
  census_cbsa_micro DECIMAL(9),
  census_mcd_fips DECIMAL(9),
  census_met_div_fips DECIMAL(9),
  census_msa_fips DECIMAL(9),
  census_place_fips DECIMAL(9)  
) DEFAULT CHARSET=utf8;