# The is the primary database used by live versions of the app. It's where active user data is stored.
CREATE DATABASE IF NOT EXISTS contacts;

# The test version of the database contains an identical schema but is used by the unit tests.
CREATE DATABASE IF NOT EXISTS contacts_test;