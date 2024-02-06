export const getFormattedDescription = (text) => {
  const splittedText = text.split("\n");

  let prevElement = null;

  // check if prev element starts with "-", if not and the current element does, insert ul tag
  const formatted = splittedText.map((element) => {
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

  return formatted.join("");
};
