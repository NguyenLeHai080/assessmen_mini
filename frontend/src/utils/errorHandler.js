export function getErrorMessage(error) {
  if (!error) return 'Da xay ra loi khong xac dinh.';
  const prefix = error.status ? `[${error.status}] ` : '';
  return `${prefix}${error.message || 'Da xay ra loi.'}`;
}
