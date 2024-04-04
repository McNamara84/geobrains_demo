function handleSaveAs() {
  // XML-Vorlage aus der Datei laden
  $.ajax({
    url: "metadata_template.xml",
    dataType: "xml",
    success: function (xmlTemplate) {
      // XML-Objekt aus der Vorlage erstellen
      var xmlDoc = $(xmlTemplate).clone();

      // Funktionen zum Einfügen von Werten in XML-Nodes
      function setXmlValue(xmlDoc, selector, value, attributes) {
        var node = xmlDoc.find(selector);
        if (node.length > 0) {
          node.text(value);
          if (attributes) {
            $.each(attributes, function (key, value) {
              node.attr(key, value);
            });
          }
        }
      }

      function appendXmlElement(xmlDoc, parentSelector, elementName, value, attributes) {
        var parentNode = xmlDoc.find(parentSelector);
        if (parentNode.length > 0) {
          var newElement = $("<" + elementName + "></" + elementName + ">");
          newElement.text(value);
          if (attributes) {
            $.each(attributes, function (key, value) {
              newElement.attr(key, value);
            });
          }
          parentNode.append(newElement);
        }
      }

      // Werte aus dem Formular in das XML-Objekt einfügen
      // DOI
      var doi = $('#inputDOI').val();
      setXmlValue(xmlDoc, 'identifier[identifierType="DOI"]', doi);
      setXmlValue(xmlDoc, 'gmd\\:fileIdentifier gco\\:CharacterString', 'doi:' + doi);
      setXmlValue(xmlDoc, 'gmd\\:linkage gmd\\:URL', 'http://dx.doi.org/doi:' + doi);
      setXmlValue(xmlDoc, 'dif\\:Entry_ID', doi);

      // Year
      var year = $('#inputPublicationYear').val();
      setXmlValue(xmlDoc, "publicationYear", year);
      setXmlValue(xmlDoc, 'dif\\:Dataset_Release_Date', year);

      // Resource Type
      setXmlValue(xmlDoc, "resourceType", "", { resourceTypeGeneral: $("#inputResourceType").find("option:selected").text() });

      // Version
      var version = $('#inputVersion').val();
      setXmlValue(xmlDoc, "version", version);

      // Language of dataset TODO: Speicherung der Abkürzung für die Sprache und nicht ausgeschrieben
      var language = $("#inputLanguageDataset").find("option:selected").text();
      setXmlValue(xmlDoc, "language", language);

      // Rights TODO: Speicherung der Abkürzung für die Rechte und nicht ausgeschrieben
      var rights = $('#inputRights').find("option:selected").text();
      setXmlValue(xmlDoc, "rights", rights);

      // Title(s)
      $('input[name="title[]"]').each(function () {
        var titleType = $(this).closest(".row").find('select[name="titleType[]"]').find("option:selected").text();
        appendXmlElement(xmlDoc, "titles", "title", $(this).val(), { titleType: titleType });
      });

      // Creator-Elemente hinzufügen
      $(".row[data-creator-row]").each(function () {
        var familyName = $(this).find('input[name="familynames[]"]').val();
        var givenName = $(this).find('input[name="givennames[]"]').val();
        var orcid = $(this).find('input[name="orcids[]"]').val();
        var affiliation = $(this).find('input[name="affiliation[]"]').val();

        var creatorElement = $("<creator></creator>");
        appendXmlElement(creatorElement, "", "creatorName", "");
        appendXmlElement(creatorElement.find("creatorName"), "", "familyName", familyName);
        appendXmlElement(creatorElement.find("creatorName"), "", "givenName", givenName);
        appendXmlElement(creatorElement, "", "nameIdentifier", orcid, { nameIdentifierScheme: "ORCID" });
        appendXmlElement(creatorElement, "", "affiliation", affiliation);

        xmlDoc.find("creators").append(creatorElement);
      });

      // XML-Dokument in einen String konvertieren
      var xmlString = new XMLSerializer().serializeToString(xmlDoc[0]);

      // Blob-Objekt mit dem XML-String erstellen
      var blob = new Blob([xmlString], { type: "application/xml" });

      // Link-Element erstellen und den Download triggern
      var link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = "metadata.xml";
      link.click();
    },
    error: function () {
      console.error("Fehler beim Laden der XML-Vorlage.");
    },
  });
}
