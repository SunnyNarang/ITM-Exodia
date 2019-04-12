package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

/**
 * Created by shriram on 7/27/2016.
 */

public class RoutineFragmentPagerAdapter extends FragmentPagerAdapter {

    final int PAGE_COUNT = 6;
    private String tabTitles[] = new String[] { "M", "T", "W","T", "F", "S" };

    public RoutineFragmentPagerAdapter(FragmentManager fm) {
        super(fm);
    }

    @Override
    public Fragment getItem(int position) {
        return PageFragment.newInstance(position+1);
    }

    @Override
    public int getCount() {
        return PAGE_COUNT;
    }

    @Override
    public CharSequence getPageTitle(int position) {
        // Generate title based on item position
        return tabTitles[position];
    }

}
