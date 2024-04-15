function generateDates($start_date, $end_date) {
    $dates = [];
    $current_date = new DateTime($start_date);
    $end = new DateTime($end_date);

    while ($current_date <= $end) {
        $dayOfWeek = $current_date->format('N');
        if ($dayOfWeek < 6) {
            $dates[] = $current_date->format('Y-m-d');
        }
        $current_date->modify('+1 day');
    }

    return $dates;
}

function distributeValues($total, $baseline, $dates) {
    $result = [];
    $weekday_count = count($dates);
    $min_per_day = $total / $weekday_count;
    $baseline_per_day = $baseline / 100 * $min_per_day;

    foreach ($dates as $date) {
        $result[$date] = $baseline_per_day;
    }

    $remaining_amount = $total - $baseline_per_day * $weekday_count;
    while ($remaining_amount > 0) {
        $index = array_rand($dates);
        $result[$dates[$index]] += mt_rand(0, $remaining_amount);
        $remaining_amount -= $result[$dates[$index]] - $min_per_day;
    }

    return $result;
}

function distributeAmount($start_date, $end_date, $total, $baseline) {
    $dates = generateDates($start_date, $end_date);
    $result = distributeValues($total, $baseline, $dates);
    return $result;
}
