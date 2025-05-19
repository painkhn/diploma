export function generateColors(count: number): string[] {
    const colors: string[] = [];
    const hueStep = 360 / count; // Равномерное распределение по цветовому кругу

    for (let i = 0; i < count; i++) {
        const hue = Math.floor(i * hueStep);
        // Используем HSL для ярких насыщенных цветов
        colors.push(`hsl(${hue}, 70%, 50%)`);
    }

    return colors;
}
