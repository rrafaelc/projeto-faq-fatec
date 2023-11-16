export const addLinksToContent = (content) => {
  const linkRegex = /((http|https):\/\/[^\s.]+[^\s]*[^\s.])/g;
  const linkReplacement = '<a href="$1" target="_blank" style="display: inline">clique aqui</a>';

  return content.replace(linkRegex, linkReplacement);
};

export const replaceLineBreaks = (content) => {
  return content.replace(/\n/g, '<br>');
};
