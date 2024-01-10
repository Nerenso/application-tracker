<template>
  <DashboardLayout title="Listing Details">
    <section class="detail-page w-full px-2 pt-6">
      <div class="max-w-5xl mx-auto w-full bg-white p-6 border rounded-lg">
        {{ listing.page_title }}

        <div class="whitespace-pre-line" v-html="testHTML"></div>
      </div>
    </section>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

// const text =
//   "Bedrijfsinformatie:\n\nelastik is een enthousiast team van strategische designers en developers gespecialiseerd in creatieve maatwerkoplossingen. Ze werken vanuit de inspirerende Caballero fabriek voor verschillende merken in Nederland en daarbuiten. Het team bestaat uit enthousiaste en veelzijdige designers en developers die plezier hebben in het ontwerpen en bouwen van high-end websites.\n\nVacature:\n\nAls front-end developer ben je verantwoordelijk voor het implementeren van de nieuwste technieken en innovaties op het gebied van webdesign en webdevelopment. Je werkt nauw samen met het team om hoogwaardige websites te ontwerpen en bouwen. Het is belangrijk dat je zowel oog hebt voor design, details en klantbeleving als voor gestructureerde code.\n\nFunctie-eisen:\n\n- Passie voor vooruitstrevende en gestructureerde code\n- HBO werk- en denkniveau\n- Assertief en zelfstandig kunnen werken\n- Gevoel voor design, details en klantbeleving\n- Ervaring met HTML en CSS\n- Redelijke kennis van JavaScript (pre)\n- Ervaring met PHP, GIT en databases (pre)\n- Kennis van Craft CMS (pre)\n- Ervaring met VS Code en Figma\n- Oplossingsgerichte mindset\n- Goede beheersing van de Nederlandse taal\n\nWat wordt er geboden:\n\n- Fulltime of parttime (24-40 uur) functie in Den Haag\n- Gezellige werkplek in een enthousiast en ambitieus team\n- Marktconform salaris met doorgroeimogelijkheden\n- Werken voor diverse klanten met direct contact\n- Persoonlijke ontwikkeling op technisch en communicatief niveau\n\nStuur je CV, portfolio en motivatie naar elastik als je jezelf herkent in het profiel en geïnteresseerd bent in deze uitdaging.";

// const text =
//   "Goedemiddag! is een no-nonsense developmentbureau uit Delft. Ze vertalen ideeën van opdrachtgevers naar succesvolle webapplicaties en geloven in maatwerk en leveren technisch hoogwaardige oplossingen. Het team is hecht en informeel en investeert in de persoonlijke ontwikkeling van collega's. Ze zijn gespecialiseerd in Laravel en Vue.js en werken aan verschillende projecten, variërend van SAAS-platforms tot gamification platformen.\n\nDeze vacature is voor een enthousiaste full stack developer die zal werken aan de (door)ontwikkeling van verschillende applicaties. Het werk is afwisselend en biedt veel ruimte voor eigen initiatief. Er is ook contact met klanten om bijvoorbeeld wijzigingen door te nemen of bugs te analyseren.\n\nVereisten:\n- Minimaal een jaar professionele ervaring met Laravel en een javascript framework zoals Vue of React\n\nWat ze bieden:\n- Een goed salaris passend bij ervaring\n- Mogelijkheid om 32, 36 of 40 uur te werken\n- Flexibele werktijden\n- Mogelijkheid om twee dagen per week vanuit huis te werken\n- 25 tot 27 vakantiedagen\n- Macbook\n- 10% van werktijd beschikbaar voor zelfontwikkeling\n- Gratis lunch\n- Reiskostenvergoeding\n- Mogelijkheid om bij te dragen aan open source initiatieven\n- Regelmatig leuke teamactiviteiten en elke vrijdag AirFryday en een drankje.\n\nVoor meer informatie of om te solliciteren, kunt u bellen, WhatsAppen of mailen naar robert@goedemiddag.nl.";

// const text =
//   "Bedrijfsinformatie:\n\nModern Minds maakt deel uit van de Zuiver Groep en is een bedrijf dat gespecialiseerd is in het creëren en beheren van WordPress-websites en WooCommerce-winkels. Het team van Modern Minds werkt samen met klanten om aan hun specifieke wensen en behoeften te voldoen. Ze streven ernaar om websites veilig, up-to-date en stabiel te houden.\n\nVacature:\n\nWordPress Developer\n\nJobomschrijving:\n\nAls WordPress Developer bij Modern Minds ben je verantwoordelijk voor het zelfstandig ontwikkelen en beheren van websites en webshops voor verschillende klanten. Je werkt gestructureerd samen met het ontwikkelingsteam om de doelen van elke week te bespreken en aan te pakken. Je communiceert met klanten om aan hun wensen te voldoen en zorgt ervoor dat de WordPress-omgeving van de klanten up-to-date blijft. Daarnaast ben je betrokken bij het opsporen en oplossen van bugs en werk je goed in teamverband.\n\nVereisten:\n\n- Minimaal 1-2 jaar ervaring als ontwikkelaar\n- Ervaring met het bouwen en beheren van WordPress-sites en WooCommerce-shops\n- Goede kennis van PHP en Javascript\n- Portfolio van eerdere samenwerkingen aan websites\n- Kritisch, creatief en analytisch denkvermogen\n- Goede beheersing van zowel Engels als Nederlands\n\nWat wij bieden:\n\n- Uitdagende en afwisselende baan met een breed klantenpakket\n- Competitief salaris in overeenstemming met kennis en ervaring\n- Vakantiegeld en bonusregeling\n- Reiskostenvergoeding\n- Laptop van de zaak\n- 24 vakantiedagen en sabbatical mogelijkheden\n- Mogelijkheid tot het volgen van trainingen en opleidingen\n- Gezamenlijke lunch en sportsessies op kantoor\n- Borrels, etentjes en uitjes om successen te vieren\n- Moderne werkplek in Rotterdam-Zestienhoven\n\nBelangrijke details:\n\n- Alleen Nederlandstalige burgers van Nederland komen in aanmerking\n- Sollicitatieformulier is beschikbaar op de website van het bedrijf\n\nNeem voor meer informatie contact op met werkenbij@zuivergroup.nl of +31 (0)10 - 309 77 00.";

// const text =
//   "Bedrijfsinformatie:\nEye-C Multimedia is een full-service internetbureau dat bedrijven ondersteunt en adviseert bij hun groei en efficiëntie. Ze zijn gespecialiseerd in het bouwen van WordPress-websites en het optimaliseren van snelheid en zoekmachineprestaties. Als partner helpt Eye-C bedrijven om succesvol online te groeien.\n\nVacatureomschrijving:\nEye-C Multimedia zoekt een creatieve WordPress-specialist/ontwikkelaar die ervaring heeft met het bouwen van WordPress-websites en het optimaliseren van snelheid en zoekmachineprestaties. Je zult zelfstandig of in teamverband werken aan de ontwikkeling van websites en webshops in WordPress. Daarnaast beheer je je eigen projecten en ben je goed op de hoogte van de mogelijkheden om websites te optimaliseren. Het is belangrijk dat je ervaring hebt met front-end talen zoals CSS, HTML en JavaScript.\n\nFunctievereisten:\n- Ervaring in het bouwen van WordPress-websites\n- Kennis van HTML, CSS, JavaScript en PHP\n- Ervaring met Woocommerce en YOAST is een pre\n- Kennis van responsive design\n- Minimaal 2 jaar ervaring in het vak\n- Beschikbaar voor een fulltime dienstverband\n\nWat bieden ze:\n- Uitdagende projecten en de kans om te werken aan diverse websites en webshops\n- Mogelijkheid om je eigen projecten te beheren\n- Een creatieve werkomgeving met enthousiaste collega's\n- Marktconform salaris en goede secundaire arbeidsvoorwaarden\n\nBelangrijke details:\n- Plaats: Den Haag\n- Opleidingsniveau: HBO/WO\n- Aantal uren: 40 uur per week\n- Je wordt onderdeel van het jonge professional team van Eye-C Multimedia\n- Sollicitaties worden vertrouwelijk behandeld";

// const text =
//   "Commandos is een bedrijf gespecialiseerd in branding en biedt verschillende branding services aan. Ze werken aan uiteenlopende projecten, waaronder de ontwikkeling van websites, online belevingen en campagnes. Als Creative Front-end developer bij Commandos ben je verantwoordelijk voor het vertalen van brand designs en concepten naar een goed werkende online omgeving. Je werkt samen met een ambitieus team en bouwt letterlijk mee aan de branding van klanten.\n\nWat wij vragen:\n- Een paar jaar ervaring als Front-end developer\n- Opleiding Communicatie en Multimedia Design (CMD) of soortgelijk\n- Zelfstandig kunnen werken en goed functioneren in een team\n- Goed kunnen werken met deadlines en onder druk\n- Interesse in design en oog voor detail en kwaliteit\n- Enthousiasme voor de nieuwste technieken\n- Communicatief sterk (Nederlands, Engels)\n\nWerkzaamheden:\n- Snel coderen en tot leven brengen van designs\n- Contact onderhouden met klanten over lopende projecten\n- Meedenken in brainstormsessies\n- Ondersteuning bieden aan online marketeers voor website optimalisaties\n\nNice to haves:\n- Per direct beschikbaar\n- Gevoel voor trends\n- Kennis van Wordpress\n- Kennis van Greensock\n\nWat wij bieden:\n- Een fulltime baan in een gezellig kantoor met leuke mensen\n- Een goed salaris, 25 vakantiedagen en 8% vakantiegeld\n- Mogelijkheid tot ontwikkeling/specialisatie\n- Ruimte voor eigen inbreng\n- Flexibiliteit met thuiswerken\n- Veel verantwoordelijkheid en vrijheid\n- Vrijdag snack dag en af en toe ontspannen feestjes\n\nAls je geïnteresseerd bent, kan je contact opnemen met Ramon Postma via ramon@commandos.nl of 0625550046.";

const text =
  "Equans is een technisch dienstverlener en internationale marktleider in technische dienstverlening. Met bijna 95.000 medewerkers in 20 landen werken ze aan oplossingen voor de digitale, industriële en energietransitie. In Nederland werken ze samen met 6.000 collega's vanuit 29 locaties.\n\nDe functie van Servicemonteur Koudetechniek bij Equans houdt in dat je verantwoordelijk bent voor service- en onderhoudswerkzaamheden aan grootschalige industriële koelinstallaties. Je lost complexe storingen op en zorgt ervoor dat de klant een goedwerkende installatie heeft. Dit doe je in de regio Zuid-Holland, Zoetermeer en omgeving. Je bent het visitekaartje van Equans en zorgt voor geweldige service voor de klant.\n\nVereisten:\n- Afgeronde mbo-opleiding in een technische richting\n- F-gassen categorie 1 (STEK) certificaat of bereidheid om dit te behalen\n- VCA-B of VCA-VOL diploma of bereidheid om dit te behalen\n- Rijbewijs B\n\nWat Equans biedt:\n- Bruto maandsalaris tot €4.200,00 op basis van ervaring\n- Een arbeidsovereenkomst voor onbepaalde tijd\n- €70,00 netto onkostenvergoeding per maand\n- 25 vakantiedagen en 13 ADV-dagen\n- Goede pensioenregeling\n- Prettige werksfeer en fijne collega's\n- Doorgroei- en opleidingsmogelijkheden\n\nBelangrijke details:\n- Storingsdiensten komen 1 keer in de 7-8 weken voor\n- Dagelijks contact met de planner over ingeplande werkzaamheden\n- Rapporteren aan de regio serviceleider op vestigingen in Roosendaal of Zoetermeer";

const splittedText = text.split("\n");
let prevElement = null;

// check if prev element starts with "-", if not and the current element does, insert ul tag
const genTest = splittedText.map((element) => {
  let stringToAdd = null;

  if (!prevElement) prevElement = element;

  if (element.slice(0, 1) == "-") {
    if (prevElement.slice(0, 3) == "<ul" || prevElement.slice(0, 4) == "<li>") {
      stringToAdd = `<li>${element.slice(2)}</li>`;
      prevElement = stringToAdd;
      return stringToAdd;
    } else {
      stringToAdd = `<ul class='list-disc ml-4 mb-4 space-y-1'><li>${element.slice(1)}</li>`;
      prevElement = stringToAdd;
      return stringToAdd;
    }
  }

  if (prevElement.slice(-5) == "</li>" && element.slice(0, 1) != "-") {
    stringToAdd = `</ul>${element}`;
    prevElement = stringToAdd;
    return stringToAdd;
  }

  if (element.slice(-1) == ":") {
    prevElement = element;
    return `<h3>${element.slice(0, -1)}</h3>`;
  } else if (element == "") {
    prevElement = element;
    return "";
  } else {
    prevElement = element;
    return element;
  }
});

const testHTML = genTest.join("");
console.log(genTest);

const props = defineProps({
  listing: Object,
});
</script>
