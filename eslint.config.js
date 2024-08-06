import js from "@eslint/js";

export default [
    js.configs.recommended,
    {
        files: ["app/**/*.js"],
        ignorePatterns: ["**/*.config.js", "vendor/*"],
        rules: {
            "max-len": "off",
            "vue/no-mutating-props": "off",
            "indent": ["error", 4],
            "semi": "error",
            "no-undef": "off" // Disable no-undef to avoid the error globally if needed
        },
        env: {
            browser: true, // Add browser environment
            node: true,
        },
    }
];
