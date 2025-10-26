
// Run with: mongosh "mongodb+srv://<user>:<pass>@<cluster>/?retryWrites=true&w=majority" --file create_database_mongodb.js
// Or: DB_NAME=wms_rosters mongosh <uri> --file create_database_mongodb.js

const DB_NAME = (typeof process !== 'undefined' && process.env && process.env.DB_NAME) || 'wms_rosters';
const dbh = db.getSiblingDB(DB_NAME);

function ensureCollection(name, validator) {
  const exists = dbh.getCollectionInfos({ name }).length > 0;
  if (!exists) {
    dbh.createCollection(name, {
      validator, validationLevel: "strict", validationAction: "error"
    });
    print(`Created collection ${name}`);
  } else {
    const res = dbh.runCommand({
      collMod: name,
      validator, validationLevel: "strict", validationAction: "error"
    });
    if (!res.ok) throw new Error(`collMod failed for ${name}: ${tojson(res)}`);
    print(`Updated validator for ${name}`);
  }
}

const shiftsValidator = {
  $jsonSchema: {
    bsonType: "object",
    required: ["location_id","shift_date","start_utc","end_utc","required_count","status"],
    properties: {
      location_id:   { bsonType: ["int","long"] },
      shift_date:    { bsonType: "date" },
      start_utc:     { bsonType: "date" },
      end_utc:       { bsonType: "date" },
      required_count:{ bsonType: "int", minimum: 1 },
      role_id:       { bsonType: ["int","long","null"] },
      status:        { enum: ["open","partially_filled","filled","cancelled"] },
      notes:         { bsonType: ["string","null"] }
    }
  }
};

const assignmentsValidator = {
  $jsonSchema: {
    bsonType: "object",
    required: ["shift_id","user_id","assigned_at"],
    properties: {
      shift_id:    { bsonType: ["int","long","objectId"] },
      user_id:     { bsonType: ["int","long"] },
      role_id:     { bsonType: ["int","long","null"] },
      assigned_at: { bsonType: "date" },
      assigned_by: { bsonType: ["int","long","null"] },
      notes:       { bsonType: ["string","null"] }
    }
  }
};

ensureCollection("shifts", shiftsValidator);
ensureCollection("assignments", assignmentsValidator);

// Indexes
dbh.shifts.createIndex({ location_id: 1, shift_date: 1 });
dbh.shifts.createIndex({ start_utc: 1 });
dbh.shifts.createIndex({ status: 1 });

dbh.assignments.createIndex({ shift_id: 1, user_id: 1 }, { unique: true });
dbh.assignments.createIndex({ user_id: 1 });
dbh.assignments.createIndex({ shift_id: 1 });

print("MongoDB initialization complete for DB:", DB_NAME);
