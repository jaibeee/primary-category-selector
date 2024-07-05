export type Category = {
  id: number;
  name: string;
};

export type ThemeVariable = {
  ajaxURL: string;
  nonce: string;
  postId: number;
  primaryCategory: number;
};

export type CategoryOptions = {
  label: string;
  value: string;
};
