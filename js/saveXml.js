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
      var doi = $("#inputDOI").val();
      setXmlValue(xmlDoc, 'identifier[identifierType="DOI"]', doi);
      setXmlValue(xmlDoc, "gmd\\:fileIdentifier gco\\:CharacterString", "doi:" + doi);
      setXmlValue(xmlDoc, "gmd\\:linkage gmd\\:URL", "http://dx.doi.org/doi:" + doi);
      setXmlValue(xmlDoc, "dif\\:Entry_ID", doi);

      // Year
      var year = $("#inputPublicationYear").val();
      setXmlValue(xmlDoc, "publicationYear", year);
      setXmlValue(xmlDoc, "dif\\:Dataset_Release_Date", year);

      // Resource Type
      setXmlValue(xmlDoc, "resourceType", "", { resourceTypeGeneral: $("#inputResourceType").find("option:selected").text() });

      // Version
      var version = $("#inputVersion").val();
      setXmlValue(xmlDoc, "version", version);

      // Language of dataset TODO: Speicherung der Abkürzung für die Sprache und nicht ausgeschrieben
      var language = $("#inputLanguageDataset").find("option:selected").text();
      setXmlValue(xmlDoc, "language", language);

      // Rights TODO: Speicherung der Abkürzung für die Rechte und nicht ausgeschrieben
      var rights = $("#inputRights").find("option:selected").text();
      setXmlValue(xmlDoc, "rights", rights);

      // Titel-Elemente hinzufügen
      var mainTitle = "";
      $('input[name="title[]"]').each(function (index) {
        var titleType = $(this).closest(".row").find('select[name="titleType[]"]').val();
        var titleText = $(this).val();

        if (titleType === "1") {
          mainTitle = titleText;
        }

        appendXmlElement(xmlDoc, "titles", "title", titleText, { titleType: titleType });
      });

      // dif:Entry_Title und dif:Dataset_Title mit dem Main Title befüllen
      setXmlValue(xmlDoc, "dif\\:Entry_Title", mainTitle);
      setXmlValue(xmlDoc, "dif\\:Dataset_Title", mainTitle);

      // Array zum Speichern der Creator-Namen
      var datasetCreators = [];

      // Creator-Elemente hinzufügen
      $(".row[data-creator-row]").each(function () {
        var familyName = $(this).find('input[name="familynames[]"]').val();
        var givenName = $(this).find('input[name="givennames[]"]').val();
        var orcid = $(this).find('input[name="orcids[]"]').val();
        var affiliation = $(this).find('input[name="affiliation[]"]').val();
        var creatorName = familyName + ", " + givenName;

        // Neues XML-Element creator erstellen
        var creator = $("<creator></creator>");
        // Neues XML-Element creatorName erstellen, mit der Variable creatorName befüllen und als Kind-Element von creator hinzufügen
        creator.append($("<creatorName></creatorName>").text(creatorName));
        creator.append($("<givenName></givenName>").text(givenName));
        creator.append($("<familyName></familyName>").text(familyName));
        creator.append($('<nameIdentifier nameIdentifierScheme="ORCID"></nameIdentifier>').text(orcid));
        creator.append($("<affiliation></affiliation>").text(affiliation));

        // Fertiges creator-Element in das XML-Objekt creators einfügen
        var creators = xmlDoc.find("creators");
        creators.append(creator);

        // Neues Element gmd:citedResponsibleParty erstellen
        var citedResponsibleParty = $("<gmd:citedResponsibleParty></gmd:citedResponsibleParty>").attr("xlink:href", "http://orcid.org/" + orcid);
        var responsibleParty = $("<gmd:CI_ResponsibleParty></gmd:CI_ResponsibleParty>");
        responsibleParty.append($("<gmd:individualName><gco:CharacterString>" + creatorName + "</gco:CharacterString></gmd:individualName>"));
        responsibleParty.append($("<gmd:organisationName><gco:CharacterString>" + affiliation + "</gco:CharacterString></gmd:organisationName>"));

        // TODO: Welche Role laut DataCite mappt zu welchem RoleCode?
        responsibleParty.append(
          $(
            '<gmd:role><gmd:CI_RoleCode codeList="http://www.isotc211.org/2005/resources/Codelist/gmxCodelists.xml#CI_RoleCode" codeListValue="author">author</gmd:CI_RoleCode></gmd:role>'
          )
        );

        citedResponsibleParty.append(responsibleParty);

        // Element gmd:CI_Citation finden
        var citation = xmlDoc.find("gmd\\:CI_Citation");
        // Neues Element gmd:citedResponsibleParty einfügen
        citation.append(citedResponsibleParty);

        // Creator-Namen zum Array hinzufügen
        datasetCreators.push(creatorName);
      });

      // Dataset_Creator-Element befüllen
      var datasetCreatorString = datasetCreators.join("; ");
      setXmlValue(xmlDoc, "dif\\:Dataset_Creator", datasetCreatorString);
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
