package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;

import android.os.Bundle;
import android.view.MenuItem;
import android.widget.TextView;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

public class Notice_Body extends AppCompatActivity {

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Notice_Body.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notice__body);

        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("ITM Notice");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);


        String head = getIntent().getStringExtra("head");
        String body = getIntent().getStringExtra("body");
        String teacher = getIntent().getStringExtra("t_name");

        TextView headtv = (TextView) findViewById(R.id.body_head);
        TextView bodytv = (TextView) findViewById(R.id.body_body);
        TextView teachertv = (TextView) findViewById(R.id.body_teacher);

        headtv.setText(head);
        bodytv.setText(body);
        teachertv.setText("- "+teacher);

    }
}
