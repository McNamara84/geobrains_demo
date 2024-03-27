# Projektbeschreibung
## Formularfelder
#### * Resource Information
**DOI**
* In diesem Feld kommt die DOI (Digital Object Identifier), die die Ressource identifiziert.
* Datentyp: Zeichenkette
* Vorkommen: 0-1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: doi in der Tabelle Resource.
* Restriktionen: Muss im Format "prefix/suffix" sein.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/identifier/)
* Schema Version: 4.5
* Beispielwerte: `10.5880/GFZ.3.1.2024.002` `10.5880/pik.2024.001`

**Publication Year**
* In diesem Feld kommt das Veröffentlichungsjahr der Ressource.
* Datentyp: Year
* Vorkommen: 1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: year in der Tabelle Resource.
* Restriktionen: Muss im Format YYYY sein.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/publicationyear/)
* Schema Version: 4.5
* Beispielwerte: `1998` `2018` `1900`

**Resource Type**
* In diesem Feld kommt der Typ der Ressource.
* Datentyp: Zeichenkette
* Vorkommen: 1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: resource_type_general in der Tabelle Resource_Type.
* Restriktionen: Muss ein „Recource Type“ ausgewählt werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/resourcetype/#a-resourcetypegeneral)
* Schema Version: 4.5
* Beispielwerte: `Dataset` `Audiovisual` `Book`

**Version**
* In diesem Feld kommt die Versionsnummer der Ressource.
* Datentyp: INT
* Vorkommen: 0-1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: version in der Tabelle Resource.
* Restriktionen: Nur Zahlen und eventuell Punkte.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/version/)
* Schema Version: 4.5
* Beispielwerte: `1.0` `2.1` `3.5`

**Language of Dataset**
* In diesem Feld kommt die Sprache des Datensatzes.
* Datentyp: Zeichenkette
* Vorkommen: 0-1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: name in der Tabelle Language.
* Restriktionen: Muss eine „Sprache“ ausgewählt werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/language/)
* Schema Version: 4.5
* Beispielwerte: `"en" Englisch` `"de" Deutsch` `"fr" Französisch`

**Title**
* In diesem Feld kommt der Titel der Ressource.
* Datentyp: Text
* Vorkommen: 1-n
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: text in der Tabelle title.
* Restriktionen: Muss angegeben werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/title/)
* Schema Version: 4.5
* Beispielwerte: `Drone based photogrammetry data at the Geysir geothermal field, Iceland`

**Title Type**
* In diesem Feld kommt die Art des Titels (außer dem Haupttitel).
* Datentyp: Zeichenkette
* Vorkommen: 0-1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: title in der Tabelle Title_Type.
* Restriktionen: Muss ein „Title Type“ ausgewählt werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/title/#a-titletype)
* Schema Version: 4.5
* Beispielwerte: `Main` `Subtitle` `Translated Title`

#### * Rights
**Rights Title**
* In diesem Feld kommt der Titel der Lizenz mit ihrer Abkürzung.
* Datentyp: Zeichenkette
* Vorkommen: 0-n
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: text und rightsIdentifier in der Tabelle Rights.
* Restriktionen: Muss eine „Linzenz“ ausgewählt werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/rights/)
* Schema Version: 4.5
* Beispielwerte: `Creative Commons Attribution 4.0 International (CC-BY-4.0)`

#### * Authors
**Lastname**
* In diesem Feld kommt der Nachname des Autors.
* Datentyp: Text
* Vorkommen: 1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: familyname in der Tabelle Author.
* Restriktionen: Muss angegeben werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/creator/#familyname)
* Schema Version: 4.5
* Beispielwerte: `Jemison` `Smith`

**Firstname**
* In diesem Feld kommt der Vorname des Autors.
* Datentyp: Text
* Vorkommen: 1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: givenname in der Tabelle Author.
* Restriktionen: Muss angegeben werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/creator/#givenname)
* Schema Version: 4.5
* Beispielwerte: `John` `Jane`

**Role**
* In diesem Feld kommt die Rolle/ Rollen des Autors.
* Datentyp: Text
* Vorkommen: 0-n
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: name in der Tabelle Role.
* Restriktionen: muss mindestens eine Rolle ausgewählt werden.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/contributor/#a-contributortype)
* Schema Version: 4.5
* Beispielwerte: `Data Manager` `Project Manager`

**Author ORCID**
* In diesem Feld kommt die ORCID des Autors (Open Researcher and Contributor ID).
* Datentyp: Zeichenkette 
* Vorkommen: 1
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: orcid in der Tabelle Author.
* Restriktionen: Muss im Format "xxxx-xxxx-xxxx-xxxx" sein.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/creator/#nameidentifier)
* Schema Version: 4.5
* Beispielwerte: `1452-9875-4521-7893` `0082-4781-1312-884x`

**Affiliation**
* In diesem Feld kommt die Zugehörigkeit des Autors.
* Datentyp: Zeichenkette
* Vorkommen: 0-n
* Das zugehörige Feld in der Datenbank, wo der Wert gespeichert wird, heißt: name in der Tabelle Affiliation.
* Restriktionen: Es ist optional.
* [Link zur Dokumentation von DataCite mit der Beschreibung des Elements im Metadaten-Schema](https://datacite-metadata-schema.readthedocs.io/en/4.5/properties/creator/#affiliation)
* Schema Version: 4.5
* Beispielwerte: `Technische Universität Berlin` `GFZ, Helmholtz-Zentrum Potsdam - Deutsches GeoForschungsZentrum GFZ`



### Datenvalidierung
* Folgende Felder müssen zwingend ausgefüllt werden: **Publication Year**, **Title**, **Lastname**, **Firstname**, **Role** und **Author ORCID**.❗
* Die restlichen Felder **DOI**, **Resource Type**, **Version**, **Language of Dataset**, **Title Type**, **Rights** und **Affiliation** können optional leer bleiben.✅

## Datenbankstruktur
### 