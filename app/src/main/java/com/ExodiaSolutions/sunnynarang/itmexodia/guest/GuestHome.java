package com.ExodiaSolutions.sunnynarang.itmexodia.guest;

import android.content.Intent;
import android.net.Uri;
import android.os.Handler;
import android.support.v4.view.ViewPager;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;


import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import java.util.Timer;
import java.util.TimerTask;

public class GuestHome extends AppCompatActivity {
    CustomPagerAdapter mCustomPagerAdapter;
    int currentPage=0;
    Handler handler;
    Runnable update;
    ViewPager mViewPager;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
               GuestHome.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_guest_home);
        //Toast.makeText(this, "Welcome Guest", Toast.LENGTH_SHORT).show();
        ActionBar actionBar = getSupportActionBar();
        // actionBar.hide();
        actionBar.setTitle("Welcome Guest");

        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        mCustomPagerAdapter = new CustomPagerAdapter(GuestHome.this);

        mViewPager = (ViewPager) findViewById(R.id.pager);
       // mViewPager. (2);
        //mViewPager.setScrollDurationFactor(2);

        mViewPager.setAdapter(mCustomPagerAdapter);

        handler = new Handler();

        update = new Runnable() {
            public void run() {
                if (currentPage ==  6) {
                    currentPage = 0;
                }
                mViewPager.setCurrentItem(currentPage++, true);
            }
        };


        new Timer().schedule(new TimerTask() {

            @Override
            public void run() {
                handler.post(update);
            }
        }, 200, 3000);

    }

    public void about(View v){
        Intent i = new Intent(GuestHome.this, AboutInstitute.class);
        startActivity(i);
    }

    public void courses(View v){
        Intent i = new Intent(GuestHome.this, CoursesOffered.class);
       // startActivity(i);
    }

    public void contact(View v){
        Intent i = new Intent(GuestHome.this,ContactUs.class);
        startActivity(i);
    }

}

