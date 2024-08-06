# run_checks.sh
#!/bin/bash

# Run ESLint
npx eslint "resources/**/*.js"

# Check the exit status of ESLint
if [ $? -ne 0 ]; then
    echo "ESLint checks failed."
    exit 1
fi

# Run PSALM
vendor/bin/psalm

# Check the exit status of PSALM
if [ $? -ne 0 ]; then
    echo "PSALM checks failed."
    exit 1
fi

echo "All checks passed successfully."
