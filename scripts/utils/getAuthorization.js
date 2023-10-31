export const getAuthorization = () => {
  const access_token = localStorage.getItem('access_token');

  return `Bearer ${access_token}`;
};
