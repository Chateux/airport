CREATE TABLE "Flight" (
  "id" int,
  "reference" varchar,
  "departureDate" datetime,
  "arrivalDate" datetime,
  "plane_id" varchar,
  "airportDepature_id" varchar,
  "airportDestination_id" varchar,
  "passengers_id" varchar,
  "escale_id" varchar,
  "crew_member_id" varchar
);

CREATE TABLE "Escale" (
  "id" int,
  "reference" varchar,
  "departureDate" datetime,
  "arrivalDate" datetime,
  "plane_id" varchar,
  "airportDepature_id" varchar,
  "airportDestination_id" varchar,
  "passengers_id" varchar
);

CREATE TABLE "Company" (
  "id" int,
  "name" varchar,
  "country" varchar
);

CREATE TABLE "Plane" (
  "id" int,
  "reference" varchar,
  "modele" varchar,
  "company_id" varchar,
  "flight_id" varchar
);

CREATE TABLE "Reservation" (
  "id" int,
  "passengers_id" varchar,
  "flight_id" varchar,
  "date" datetime
);

CREATE TABLE "CrewMember" (
  "id" int,
  "firstname" varchar,
  "lastname" varchar,
  "role" varchar
);

CREATE TABLE "Passenger" (
  "id" int,
  "firstname" varchar,
  "lastname" varchar,
  "dateBirth" datetime,
  "phone" varchar,
  "email" varchar,
  "flight_id" varchar,
  "baggage_id" varchar
);

CREATE TABLE "Baggage" (
  "id" int,
  "type" int,
  "weight" varchar
);

CREATE TABLE "Airport" (
  "id" int,
  "name" varchar,
  "country" varchar,
  "flight_departure_id" varchar,
  "flight_destination_id" varchar
);

CREATE TABLE "Model" (
  "id" int,
  "reference" varchar,
  "seat" integer,
  "weight" float,
  "lenght" float,
  "width" float,
  "brand" varchar,
  "plane_id" varchar
);

CREATE TABLE "User" (
  "id" int
);

ALTER TABLE "Flight" ADD FOREIGN KEY ("plane_id") REFERENCES "Plane" ("id");

ALTER TABLE "Flight" ADD FOREIGN KEY ("escale_id") REFERENCES "Escale" ("id");

ALTER TABLE "Flight" ADD FOREIGN KEY ("airportDepature_id") REFERENCES "Airport" ("id");

ALTER TABLE "Flight" ADD FOREIGN KEY ("airportDestination_id") REFERENCES "Airport" ("id");

ALTER TABLE "Flight" ADD FOREIGN KEY ("passengers_id") REFERENCES "Airport" ("id");

ALTER TABLE "Flight" ADD FOREIGN KEY ("crew_member_id") REFERENCES "CrewMember" ("id");

ALTER TABLE "Escale" ADD FOREIGN KEY ("plane_id") REFERENCES "Plane" ("id");

ALTER TABLE "Escale" ADD FOREIGN KEY ("airportDepature_id") REFERENCES "Airport" ("id");

ALTER TABLE "Escale" ADD FOREIGN KEY ("airportDestination_id") REFERENCES "Airport" ("id");

ALTER TABLE "Escale" ADD FOREIGN KEY ("passengers_id") REFERENCES "Airport" ("id");

ALTER TABLE "Plane" ADD FOREIGN KEY ("company_id") REFERENCES "Company" ("id");

ALTER TABLE "Plane" ADD FOREIGN KEY ("flight_id") REFERENCES "Flight" ("id");

ALTER TABLE "Reservation" ADD FOREIGN KEY ("passengers_id") REFERENCES "Passenger" ("id");

ALTER TABLE "Reservation" ADD FOREIGN KEY ("flight_id") REFERENCES "Flight" ("id");

ALTER TABLE "Passenger" ADD FOREIGN KEY ("baggage_id") REFERENCES "Baggage" ("id");

ALTER TABLE "Passenger" ADD FOREIGN KEY ("flight_id") REFERENCES "Flight" ("id");

ALTER TABLE "Airport" ADD FOREIGN KEY ("flight_destination_id") REFERENCES "Flight" ("id");

ALTER TABLE "Airport" ADD FOREIGN KEY ("flight_departure_id") REFERENCES "Flight" ("id");

ALTER TABLE "Model" ADD FOREIGN KEY ("plane_id") REFERENCES "Plane" ("id");

ALTER TABLE "Airport" ADD FOREIGN KEY ("country") REFERENCES "Airport" ("id");