module.exports = function () {
	return function ({e, addUtilities, theme, variants}) {
		const themeColors = theme('colors');

		const accentColors = Object.keys(themeColors)
			.reduce((acc, key) => {
				if (typeof themeColors[key] === 'string') {
					return {
						...acc,
						[`.accent-${e(key)}`]: {
							'accent-color': themeColors[key]
						},
					};
				}

				if (typeof themeColors[key] === 'function') {
					return {
						...acc,
						[`.accent-${e(key)}`]: {
							'accent-color': themeColors[key]({}),
						},
					};
				}

				const colorShades = Object.keys(themeColors[key]);

				return {
					...acc,
					...colorShades.reduce((a, shade) => ({
						...a,
						[`.accent-${e(key)}-${shade}`]: {
							'accent-color': themeColors[key][shade]
						},
					}), {}),
				};

			}, {});

		addUtilities(accentColors, variants('accentColor', ['responsive', 'dark', 'group-hover', 'focus-within', 'hover', 'focus']));
	}
}
